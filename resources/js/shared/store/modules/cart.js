import {ADD_TO_CART, REMOTE_FROM_CART, SET_CART} from "../mutation-types";

/**
 * @typedef {object} CartItem
 * @property {object} bookable
 * @property {String} bookable.id
 * @property {object} price
 * @property {number} price.total
 */

export default {
    state: {
        cart: {
            /** @type {CartItem[]} */
            items: []
        }
    },
    mutations: {
        /**
         * Sets cart state
         * @param state
         * @param payload
         */
        [SET_CART](state, payload) {
            state.cart = payload;
        },

        /**
         * Changes cart state
         * @param state
         * @param payload
         */
        [ADD_TO_CART](state, payload) {
            state.cart.items.push(payload);
        },

        /**
         * Changes cart state
         * @param state
         * @param payload
         */
        [REMOTE_FROM_CART](state, payload) {
            state.cart.items = state.cart.items.filter(item => item.bookable.id !== payload);
        },
    },
    getters: {
        cartCount: state => state.cart.items.length,
        cartItems: state => state.cart.items,
        findCartItem: state => id => state.cart.items.find(item => item.bookable.id === id),
        cartTotal: state => state.cart.items.reduce((sum, item) => sum + item.price.total, 0)
    },
    actions: {
        /**
         * Persists cart state into a localStorage
         *
         * @param {Store} context
         * @param payload
         */
        async 'setCart'({commit}, payload) {
            commit(SET_CART, payload);
            localStorage.setItem('shoppingCart', JSON.stringify(payload));
        },

        /**
         * Changes cart state and persists it
         *
         * @param {Store} context
         * @param payload
         */
        async 'addItemToCart'({commit, dispatch, state}, payload) {
            commit(ADD_TO_CART, payload);
            await dispatch('setCart', state.cart);
        },

        /**
         * Changes cart state and persists it
         *
         * @param {Store} context
         * @param payload
         */
        async 'removeItemFromCart'({commit, dispatch, state}, payload) {
            commit(REMOTE_FROM_CART, payload);
            await dispatch('setCart', state.cart);
        },

        /**
         * Persists empty cart state
         *
         * @param {Store} context
         */
        async 'emptyCart'({dispatch}) {
            await dispatch('setCart', []);
        }
    }
}
