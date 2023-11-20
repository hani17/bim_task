import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                // primary: '#45C5E9',
                secondary: '#b0bec5',
                primary: '#45c5e9',
            },
        },
    },
});
