<template>
    <div class="container">
        <div class="row mb-5"
            :class="{ 'card-header shadow': hasPrimaryArea || hasSecondaryArea }">
            <div class="col-12 d-flex justify-content-center align-items-center mt-4">
                <button class="btn bg-cyan text-light dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="la la-calendar"></i> {{ localSelectedYear }}
                </button>
                <div class="dropdown-menu" aria-labelledby="yearDropdown">
                    <a class="dropdown-item" v-for="year in years" :key="year" @click="selectYear(year)">{{ year }}</a>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div v-if="farmTotalArea" class="row mb-4">
                    <div class="col ml-3"><b>Kɛnɛ mumɛ</b></div>
                    <div class="col text-left"><b>{{ farmTotalArea }} ha</b></div>
                </div>
            </div>

        </div>

        <div v-if="hasPrimaryArea" class="mt-5">
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
                            {{ crop.area.toFixed(2) }} ha</b>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div v-if="hasSecondaryArea" class="mt-3">
            <b>Sɛnɛfen wɛrɛw kelen-kelen kɛnɛ</b>
        </div>
        <div>

                <div class="d-flex col mt-4" v-for="crop in farmSecondaryArea" :key="crop.id">
                                <div class="row pb-5">
                    <div>
                        <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
                    </div>
                    <div class="text-left">
                        <b>{{ crop.label_bm }}<br>
                            {{ crop.area.toFixed(2) }} ha</b>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch, computed } from 'vue';

const props = defineProps({
    farmTotalArea: Number,
    farmPrimaryArea: Object,
    farmSecondaryArea: Object,
    selectedYear: String,
    years: Array
});

const emit = defineEmits(['updateYear']);
const localSelectedYear = ref(props.selectedYear);

const selectYear = (year) => {
    localSelectedYear.value = year;
    emit('updateYear', year);
};

watch(() => props.selectedYear, (newYear) => {
    localSelectedYear.value = newYear;
});

const hasPrimaryArea = computed(() => props.farmPrimaryArea && props.farmPrimaryArea.length > 0);
const hasSecondaryArea = computed(() => props.farmSecondaryArea && props.farmSecondaryArea.length > 0);

</script>
