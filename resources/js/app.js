require('./bootstrap');

import router from "./router/router";
import store from './store/index';

window.Vue = require('vue')
import App from './App.vue';
Vue.createApp(App).use(router).use(store).mount("#app");
import 'bootstrap/dist/js/bootstrap.js';
