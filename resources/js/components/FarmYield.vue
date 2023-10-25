<template>
    <div>
        <div class="row pb-5">
            <div class="d-flex col mt-4" v-for="crop in farmYield.cropYields" :key="crop.id">
                <div>
                    <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
                </div>
                <div class="text-left">
                    <b>{{ crop.label_bm }}<br>
                        {{ crop.yield }} kg/taari</b>
                </div>
            </div>
        </div>
    </div>
</template>
    
<script setup>

const props = defineProps({
    farmYield: Object,
});

</script>