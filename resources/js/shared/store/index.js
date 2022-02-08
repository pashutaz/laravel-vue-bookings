import cart from "./modules/cart";

export default {
    modules: {
        cart
    },
    state: {
        lastDateCheck: {
            from: null,
            to: null
        }
    },
    mutations: {
        setLastDateCheck(state, payload) {
            state.lastDateCheck = payload;
        }
    },
    getters: {
        from: state => state.lastDateCheck.from,
        to: state => state.lastDateCheck.to
    },
    actions: {
        setLastDateCheck(context, payload) {
            context.commit('setLastDateCheck', payload);
            localStorage.setItem('lastDateCheck', JSON.stringify(payload));
        },
        loadStateFromStorage(context) {
            const lastDateCheck = localStorage.getItem('lastDateCheck');
            if (lastDateCheck) {
                context.commit('setLastDateCheck', JSON.parse(lastDateCheck));
            }

            const cart = localStorage.getItem('shoppingCart');
            if (cart) {
                context.commit('setCart', JSON.parse(cart));
            }
        }
    }
}
