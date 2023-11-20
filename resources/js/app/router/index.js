import Vue from "vue";
import Router from "vue-router";
import store from "../store";

import Transaction from "../pages/transactions";
import Login from "../pages/login";

Vue.use(Router);

const routingMap = [
    {
        path: "/",
        name: 'transactions',
        component: Transaction,
        meta:{
            title: "View Tasks"
        },
        beforeEnter: async (to, from, next) => {
            // Fetch user details before entering the route
            try {
                await store.dispatch('getUser');
                next();
            } catch (error) {
                next('/login');
            }
        },
    },
    {
        path: "/login",
        name: 'login',
        component: Login,
        meta:{
            title: "Login"
        }
    },
];

const router = new Router({
    mode: "history",
    routes: routingMap,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }else if(to.params.savePosition){
            return {}
        } else {
            return { x: 0, y: 0 };
        }
    }
});

// router.beforeEach((to, from, next) => {
//     const isAuthenticated = store.state.isAuthenticated;
//
//     if (isAuthenticated && to.path === '/login') {
//         // If already authenticated and trying to access login, redirect to home
//         next('/');
//     } else if (!isAuthenticated) {
//         // If not authenticated, set a flag to indicate that authentication check is in progress
//         store.commit('setAuthenticationInProgress', true);
//
//         // Attempt to fetch user details
//         store.dispatch('getUser')
//             .then((user) => {
//                 if (user) {
//                     next('/');
//                 } else {
//                   next('/login');
//                 }
//             })
//             .catch((error) => {
//                 console.error('Error fetching user details:', error);
//
//                 // If fetching user details fails, redirect to login
//                 next('/login');
//             })
//             .finally(() => {
//                 // Reset the flag after authentication check is complete
//                 store.commit('setAuthenticationInProgress', false);
//             });
//     } else if (!store.state.authenticationInProgress) {
//         // User is authenticated, and authentication check is not in progress
//         // Allow access to the route
//         next();
//     }
// });



export default router;
