<template>
    <div>

        <div class="card-header shadow mb-4">
            <div class="row my-4">
                <div class="col ml-4"><b>Musaka mumɛ</b></div>
                <div class="col text-left"><b>{{ farmTotalCost }} drm</b></div>
            </div>
        </div>

        <div v-for="crop in farmCropCosts" :key="crop.id">
            <div class="center" style="width:90%; margin:auto">
                    <button type="button" class="btn btn-secondary text-dark text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="selectedCrop = selectedCrop==crop.id ? null : crop.id">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/${crop.nom_fichier_image}`" height="70"/>
                            </div>
                            <div class="col text-left pt-3">
                                <b>{{ crop.label_bm }}<br>
                                    {{ crop.cost }} drm</b>
                            </div>
                        </div>
                    </button>
                <div v-if="selectedCrop==crop.id" class="mt-3 mb-5">
                    <div v-for="(cost, name) in crop.individual_costs" :key="cost">
                        <div class="row">
                            <div class="col-7 text-left ml-4">
                                {{ name }} 
                            </div>
                            <div class="col text-left pl-2">
                                <b>{{ cost }} drm</b>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref} from "vue";

const props = defineProps({
    farmTotalCost: Number,
    farmCropCosts: Object,
});

let selectedCrop = ref()

</script>