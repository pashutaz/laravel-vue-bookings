import {SET_LOGGED_IN, SET_USER} from "../mutation-types";
import {isLoggedIn, logOut} from "../../auth";

export default {
    state: {
        isLoggedIn: false,
        user: {}
    },
    mutations: {
        [SET_USER](state, payload) {
            state.user = payload;
        },

        [SET_LOGGED_IN](state, payload) {
            state.isLoggedIn = payload;
        }
    },
    getters: {
        isUserLoggedIn: state => state.isLoggedIn
    },
    actions: {
        async logOut({commit}) {
            commit(SET_USER, {});
            commit(SET_LOGGED_IN, false);
            logOut();
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
}
