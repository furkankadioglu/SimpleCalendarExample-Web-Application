require('./bootstrap');
require("../sass/fullcalendar.css");

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate'
import {routes} from './routes.js';
import storeData from './store.js';
import auth, { isJwtExpired } from './partials/auth.js';
import MainApp from './components/MainApp.vue';
import axios from 'axios';

// Use validator, router, vuex
Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(Vuex);


const router = new VueRouter({
    routes,
    mode: 'history'
});

const store = new Vuex.Store(storeData);


axios.interceptors.request.use(function (config) {
        console.log(config);
        return config;
    }, 
    function (error) {
        console.log("HATA");
        return Promise.reject(error);
});


router.beforeEach((to, from, next) => {

    // Check JWT
    if(isJwtExpired(storeData))
    {
        store.commit('logout');
        if(next !== null)
        {
            next({
                path: '/login'
            });
        }
        return;
    }

    // Redirect if logged in to calendar.
    if (to.matched.some(record => record.name == "home")) 
    {
        if(storeData.state.isLoggedIn)
        {
            next({
                path: '/dashboard'
              });
        }
        else
        {
            next();
        }
    } 
    else 
    {
        next();
    }
});
  

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
