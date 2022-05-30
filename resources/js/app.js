

require('./bootstrap');
import router from './routes';
import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexComponent from './IndexComponent';

window.Vue = require('vue').default;
Vue.use(VueRouter);


const app = new Vue({
    el: '#app',
    router,
    components: {
        'index': IndexComponent,
    }
});

