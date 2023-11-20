<template>
    <v-app>
        <v-app-bar color="primary" dark app>
            <v-toolbar-title>Bim Task {{ $store.state.user ? $store.state.user.email : '' }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn
                    text
                    v-for="item in menuItems"
                    :key="item.title"
                    exact
                    :to="item.path">
                    <v-icon left dark>{{ item.icon }}</v-icon>
                    {{ item.title }}
                </v-btn>
                <v-btn text @click="logout" v-if="$store.state.isAuthenticated">
                    Logout
                </v-btn>
            </v-toolbar-items>
        </v-app-bar>

        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import {logout} from "./api/auth";

export default {
    name: "App",
    data () {
        return {
            menuItems: [
                { title: 'Transactions', path: '/', icon: 'task' }
            ]
        }
    },
    methods: {
        logout() {
            logout()
                .then(res => location.href = '/')
                .catch(err => {console.log(err)});
        }
    },
}
</script>

<style scoped>

</style>
