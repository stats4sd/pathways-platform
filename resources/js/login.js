import {createApp} from 'vue/dist/vue.esm-bundler';
import {Suspense} from "vue";
import FarmLogin from "./components/FarmLogin.vue";

createApp()
    .component('FarmLogin', FarmLogin)
    .component('Suspense', Suspense)
    .mount('#farm-login-card')
