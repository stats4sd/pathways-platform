import {createApp} from 'vue/dist/vue.esm-bundler';
import FarmAdmin from "./components/FarmAdmin.vue";
import axios from 'axios';
// import './bootstrap';
import {onMounted, ref} from "vue";

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

createApp()
    .component('farm-admin', FarmAdmin)
    .mount('#farm-admin');
