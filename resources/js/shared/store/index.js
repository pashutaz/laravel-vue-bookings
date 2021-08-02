export default {
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
        loadLastDateCheck(context) {
            const lastDateCheck = localStorage.getItem('lastDateCheck');

            if (lastDateCheck) {
                context.commit('setLastDateCheck', JSON.parse(lastDateCheck));
            }
        }
    }
}
