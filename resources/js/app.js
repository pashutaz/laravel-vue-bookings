require('./bootstrap');

import Vue from "vue";
import VueRouter from 'vue-router';
import router from './routes';
import store from "./shared/store";
import moment from 'moment';
import Toast, {POSITION} from "vue-toastification";
import Index from './index.vue';
import "vue-toastification/dist/index.css";

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const files = require.context('./shared/components', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component("star-rating", require('./shared/components/StarRating.vue').default);
// Vue.component("fatal-error", require('./shared/components/FatalError.vue').default);
// Vue.component("success-response", require('./shared/components/SuccessResponse.vue').default);

Vue.use(VueRouter);
Vue.use(Toast, {
    position: POSITION.BOTTOM_RIGHT,
    showCloseButtonOnHover: true,
    maxToasts: 5,
});
Vue.filter("fromNow", value => moment(value).fromNow());

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {Index},

    beforeCreate() {
        this.$store.dispatch('loadStateFromStorage');
        this.$store.dispatch('loadUser');
    }
});
