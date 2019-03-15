require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate'
import {routes} from './routes.js';
import storeData from './store.js';
import MainApp from './components/MainApp.vue';




Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(Vuex);



const router = new VueRouter({
    routes,
    mode: 'history'
});


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.name == "home")) {
        if(storeData.state.isLoggedIn)
        {
            next({
                path: '/calendar'
              });
        }
        else
        {
            next();
        }
    } else {
      next();
    }
  })
  
const store = new Vuex.Store(storeData);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});

require("../sass/fullcalendar.css");