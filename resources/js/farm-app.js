import {createApp} from 'vue/dist/vue.esm-bundler';
import FarmApp from "./components/FarmApp.vue";
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

createApp()
    .component('FarmApp', FarmApp)
    .mount('#farm-app')
