import cart from "./modules/cart";
import {SET_CART, SET_LAST_DATE_CHECK} from "./mutation-types";

export default {
    modules: { cart },
    state: {
        lastDateCheck: {
            from: null,
            to: null
        }
    },
    /** @type {import('vuex').MutationTree} */
    mutations: {
        [SET_LAST_DATE_CHECK](state, payload) {
            state.lastDateCheck = payload;
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
        async 'setLastDateCheck'({commit}, payload) {
            commit(SET_LAST_DATE_CHECK, payload);
            localStorage.setItem('lastDateCheck', JSON.stringify(payload));
        },

        /**
         * Init state loading from local storage
         *
         * @param {Store} context
         */
        async 'loadStateFromStorage'({commit}) {
            const lastDateCheck = localStorage.getItem('lastDateCheck');
            if (lastDateCheck) {
                commit(SET_LAST_DATE_CHECK, JSON.parse(lastDateCheck));
            }

            const cart = localStorage.getItem('shoppingCart');
            if (cart) {
                commit(SET_CART, JSON.parse(cart));
            }
        }
    }
}
