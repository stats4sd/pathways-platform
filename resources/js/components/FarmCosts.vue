<template>
    <div>

        <div class="card-header shadow mb-4">
            <div class="row my-4">
                <div class="col ml-4"><b>Musaka mumɛ</b></div>
                <div class="col text-left"><b>{{ farmTotalCost }} drm</b></div>
            </div>
        </div>

        <div class="row pb-5">
            <div class="d-flex col mt-4" v-for="crop in farmCropCosts" :key="crop.id">
                <div>
                    <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
                </div>
                <div class="text-left">
                    <b>{{ crop.label_bm }}<br>
                        {{ crop.cost }} drm</b>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>

const props = defineProps({
    farmTotalCost: Object,
    farmCropCosts: Object,
});

</script>