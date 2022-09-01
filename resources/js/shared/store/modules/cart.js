export default {
    state: {
        cart: {
            items: []
        }
    },
    mutations: {
        /**
         * Sets cart state
         * @param state
         * @param payload
         */
        setCart(state, payload) {
            state.cart = payload;
        },

        /**
         * Changes cart state
         * @param state
         * @param payload
         */
        addItemToCart(state, payload) {
            state.cart.items.push(payload);
        },

        /**
         * Changes cart state
         * @param state
         * @param payload
         */
        removeItemFromCart(state, payload) {
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
         * @param context
         * @param payload
         */
        async setCart({commit}, payload) {
            commit('setCart', payload);
            localStorage.setItem('shoppingCart', JSON.stringify(payload));
        },

        /**
         * Commits mutation and then dispatches an action
         *
         * @param context
         * @param payload
         */
        async addItemToCart({commit, dispatch, state}, payload) {
            commit('addItemToCart', payload);
            dispatch('setCart', state.cart);
        },

        /**
         * Changes cart state and persist it
         *
         * @param context
         * @param payload
         */
        async removeItemFromCart({commit, dispatch, state}, payload) {
            commit('removeItemFromCart', payload);
            dispatch('setCart', state.cart);
        }
    }
}
