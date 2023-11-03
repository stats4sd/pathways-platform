<template>
    <div>
        
        <div class="card-header shadow mb-4">
            <div class="row my-4">
                <div class="col ml-3"><b>Kɛnɛ mumɛ</b></div>   
                <div class="col text-left"><b>{{ farmTotalArea }} ha</b></div>
            </div>
        </div>

        <div class="mt-5">
            <b>Sɛnɛfen jɔnjɔn kelen-kelen kɛnɛ</b>
        </div>
        <div>
            <div class="row">
                <div class="d-flex col mt-4" v-for="crop in farmPrimaryArea" :key="crop.id">
                    <div>
                        <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
                    </div>
                    <div class="text-left">
                        <b>{{ crop.label_bm }}<br>
                            {{ crop.area }} ha</b>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        <div class="mt-3">
            <b>Sɛnɛfen wɛrɛw kelen-kelen kɛnɛ</b>
        </div>
        <div>
            <div class="row pb-5">
                <div class="d-flex col mt-4" v-for="crop in farmSecondaryArea" :key="crop.id">
                    <div>
                        <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
                    </div>
                    <div class="text-left">
                        <b>{{ crop.label_bm }}<br>
                            {{ crop.area }} ha</b>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>

const props = defineProps({
    farmTotalArea: Object,
    farmPrimaryArea: Object,
    farmSecondaryArea: Object
});

</script>