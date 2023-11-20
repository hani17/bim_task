import './bootstrap';

window.Vue = require('vue').default;

import Vue from 'vue'
import App from './app/App.vue'
import router from "./app/router";
import store from "./app/store";
import vuetify from './app/plugins/vuetify.js'


new Vue({
    store,
    router,
    vuetify,
    render: h => h(App),
}).$mount('#app')
