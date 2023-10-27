<template>
    <div>
        <div class="row mb-5">
            <div class="d-flex col mt-4" v-for="crop in farmProduction.cropProductions" :key="crop.id">
                <div>
                    <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
                </div>
                <div class="text-left">
                    <b>{{ crop.label_bm }}<br>
                        {{ crop.production }} kg</b>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    farmProduction: Object,
});

</script>