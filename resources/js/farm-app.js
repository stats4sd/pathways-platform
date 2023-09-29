import {createApp} from 'vue/dist/vue.esm-bundler';

import FarmPage from "./components/FarmPage.vue";

import {onMounted, ref} from "vue";

import './bootstrap';

createApp()
    .component('farm-page', FarmPage)
    .mount('#farm-app');
