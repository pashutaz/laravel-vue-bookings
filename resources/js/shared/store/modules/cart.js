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
        }
    },
    getters: {
        cartCount: state => state.cart.items.length,
        cartItems: state => state.cart.items,
        getCartItemById: state => id => state.cart.items.find(item => item.bookable.id === id)
    },
    actions: {
    }
}
