<template>
    <v-container>
        <v-row dense class="justify-content-center">
            <v-col cols="4"></v-col>
            <v-col cols="4">
                <h1 class="my-6">Login As</h1>
                <div>
                    <v-tabs v-model="tab" show-arrows icons-and-text light grow>
                        <v-tabs-slider></v-tabs-slider>
                        <v-tab v-for="(i, index) in tabs" :key="index">
                            <v-icon large>{{ i.icon }}</v-icon>
                            <div class="caption py-1">{{ i.name }}</div>
                        </v-tab>
                        <v-tab-item>
                            <v-card class="px-4">
                                <v-card-text>
                                    <v-form ref="loginForm" v-model="valid" lazy-validation>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field v-model="loginEmail" :rules="loginEmailRules" label="E-mail" required></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field v-model="loginPassword" :append-icon="show1?'eye':'eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" hint="At least 8 characters" counter @click:append="show1 = !show1"></v-text-field>
                                            </v-col>
                                            <v-col class="d-flex" cols="12" sm="6" xsm="12">
                                            </v-col>
                                            <v-spacer></v-spacer>
                                            <v-col class="d-flex" cols="12" sm="3" xsm="12" align-end>
                                                <v-btn x-large block :disabled="!valid" color="success" @click="login"> Login </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card class="px-4">
                                <v-card-text>
                                    <v-form ref="loginForm" v-model="valid" lazy-validation>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field v-model="loginEmail" :rules="loginEmailRules" label="E-mail" required></v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field v-model="loginPassword" :append-icon="show1?'eye':'eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" hint="At least 8 characters" counter @click:append="show1 = !show1"></v-text-field>
                                            </v-col>
                                            <v-col class="d-flex" cols="12" sm="6" xsm="12">
                                            </v-col>
                                            <v-spacer></v-spacer>
                                            <v-col class="d-flex" cols="12" sm="3" xsm="12" align-end>
                                                <v-btn x-large block :disabled="!valid" color="success" @click="login"> Login </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {loginAsCustomer, loginAsAdmin, getCsrf} from "../../api/auth";
import {getTransactionsForAdmin} from "../../api/transactions";

export default {
    name: "Login",
    methods: {
        validate() {

        },
        reset() {
            this.$refs.form.reset();
        },
        resetValidation() {
            this.$refs.form.resetValidation();
        },
        async login() {
            if (this.$refs.loginForm.validate()) {
                const data = {
                    email: this.loginEmail,
                    password: this.loginPassword,
                };

                getCsrf()
                    .then(() => {
                        console.log(this.tab, this.tab === 0);
                        const login = this.tab === 0 ? loginAsCustomer : loginAsAdmin;
                        login(data).then((response) => {
                            this.$router.push('/').catch(() => {});
                        })
                            .catch((error) => {
                                console.error('Error during login:', error);
                            });
                    })
                    .catch((error) => {
                        console.error('Error during login:', error);
                    });
            }
        }
    },
    data: () => ({
        dialog: true,
        tab: 0,
        tabs: [
            {name:"Customer", icon:"mdi-account"},
            {name:"Admin", icon:"mdi-account-outline"}
        ],
        valid: true,

        verify: "",
        loginPassword: "",
        loginEmail: "",
        loginEmailRules: [
            v => !!v || "Required",
            v => /.+@.+\..+/.test(v) || "E-mail must be valid"
        ],

        show1: false,
        rules: {
            required: value => !!value || "Required.",
            min: v => (v && v.length >= 8) || "Min 8 characters"
        }
    })
}
</script>

<style scoped>

</style>
