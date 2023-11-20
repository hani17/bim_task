import Vue from 'vue'
import Vuex from 'vuex'
import {loginAsAdmin, loginAsCustomer, getUser} from "../api/auth";

Vue.use(Vuex)


export default new Vuex.Store({
    state: {
        isAuthenticated: false,
        isAdmin: false, // Add isAdmin property
        user: null,
        authenticationInProgress: false
    },
    mutations: {
        setAuthentication(state, { isAuthenticated, isAdmin, user }) {
            state.isAuthenticated = isAuthenticated;
            state.isAdmin = isAdmin;
            state.user = user;
        },
        setAuthenticationInProgress(state, value) {
            state.authenticationInProgress = value;
        },
    },
    actions: {
        getUser({ commit }) {
            return new Promise((resolve, reject) => {
                getUser().then(res => {
                    const user = res.data;
                    console.log(user);
                    if (user) {
                        const isAdmin = user.role === 2;
                        commit('setAuthentication', { isAuthenticated: true, isAdmin, user: user });
                        resolve(user);
                    }
                    resolve(null);
                }).catch(err => {
                    commit('setAuthentication', { isAuthenticated: false, isAdmin: false, user: null });
                    reject(err);
                })
            });
        },
        logout({ commit }) {
            // Implement your logout logic here
            commit('setAuthentication', { isAuthenticated: false, isAdmin: false });
        },
    },
});
