import Vue from "vue";
import Vuex from "vuex";
import {isLoggedIn, logOut} from "../auth";

// modules
import cart from "./modules/cart";
import {SET_CART, SET_LAST_DATE_CHECK, SET_LOGGED_IN, SET_USER} from "./mutation-types";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {cart},
    state: {
        lastDateCheck: {
            from: null,
            to: null
        },
        isLoggedIn: false,
        user: {}
    },
    /** @type {import('vuex').MutationTree} */
    mutations: {
        [SET_LAST_DATE_CHECK](state, payload) {
            state.lastDateCheck = payload;
        },

        [SET_USER](state, payload) {
            state.user = payload;
        },

        [SET_LOGGED_IN](state, payload) {
            state.isLoggedIn = payload;
        }
    },
    /** @type {import('vuex').GetterTree} */
    getters: {
        from: state => state.lastDateCheck.from,
        to: state => state.lastDateCheck.to
    },
    /** @type {import('vuex').ActionTree} */
    actions: {
        /**
         * Remember dates last search
         *
         * @param {Store} context
         * @param payload
         */
        async setLastDateCheck({commit}, payload) {
            commit(SET_LAST_DATE_CHECK, payload);
            localStorage.setItem('lastDateCheck', JSON.stringify(payload));
        },

        async logOut({commit}) {
            commit(SET_USER, {});
            commit(SET_LOGGED_IN, false);
            logOut();
        },

        /**
         * Init state loading from local storage
         *
         * @param {Store} context
         */
        async loadStateFromStorage({commit}) {
            const lastDateCheck = localStorage.getItem('lastDateCheck');
            if (lastDateCheck) {
                commit(SET_LAST_DATE_CHECK, JSON.parse(lastDateCheck));
            }

            const cart = localStorage.getItem('shoppingCart');
            if (cart) {
                commit(SET_CART, JSON.parse(cart));
            }
        },

        async loadUser({commit, dispatch}) {
            if (isLoggedIn()) {
                try {
                    const user = (await axios.get('/user')).data;
                    commit(SET_USER, user);
                    commit(SET_LOGGED_IN, true);
                } catch (e) {
                    dispatch('logOut');
                }
            }
        }
    }
});
