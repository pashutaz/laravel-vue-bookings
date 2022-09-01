require('./bootstrap');

import VueRouter from 'vue-router';
import router from './routes';
import Vuex from 'vuex';
import Index from './index';

import moment from 'moment';
import StarRating from './shared/components/StarRating.vue';
import FatalError from "./shared/components/FatalError";
import SuccessResponse from "./shared/components/SuccessResponse";
import Store from "./shared/store";

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component(
//     'example-component',
//     require('./components/ExampleComponent.vue').default
// );


Vue.use(VueRouter);
Vue.use(Vuex);

Vue.filter("fromNow", value => moment(value).fromNow());

Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("success-response", SuccessResponse);

const store = new Vuex.Store(Store);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "index": Index
    },
    beforeCreate() {
        this.$store.dispatch('loadStateFromStorage');
    }
});
