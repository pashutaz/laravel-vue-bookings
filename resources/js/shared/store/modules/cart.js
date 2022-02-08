export default {
    state: {
        cart: {
            items: []
        }
    },
    mutations: {
        addItemToCart(state, payload) {
            state.cart.items.push(payload);
        },
        removeItemFromCart(state, payload) {
            state.cart.items = state.cart.items.filter(item => item.bookable.id !== payload);
        },
        setCart(state, payload) {
            state.cart = payload;
        }
    },
    getters: {
        cartCount: state => state.cart.items.length,
        cartItems: state => state.cart.items,
        getCartItemById: state => id => state.cart.items.find(item => item.bookable.id === id)
    },
    actions: {
        setCart({ commit }, payload) {
            commit('setCart', payload);
            localStorage.setItem('shoppingCart', JSON.stringify(payload));
        },
        addItemToCart({ commit, dispatch, state }, payload) {
            commit('addItemToCart', payload);
            dispatch('setCart', state.cart);
        },
        removeItemFromCart({ commit, dispatch, state }, payload) {
            commit('removeItemFromCart', payload);
            dispatch('setCart', state.cart);
        }
    }
}
