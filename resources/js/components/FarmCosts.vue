<template>
    <div>

<div class="row mb-5">
      <div class="col-12 d-flex justify-content-between align-items-center mt-4">
        <div>
          <button class="btn btn-info dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="la la-calendar"></i> {{ localSelectedYear }}
          </button>
          <div class="dropdown-menu" aria-labelledby="yearDropdown">
            <a class="dropdown-item" v-for="year in years" :key="year" @click="selectYear(year)">{{ year }}</a>
          </div>
        </div>
      </div>
</div>
        <div v-if="farmTotalCost" class="card-header shadow mb-4">
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
                <div v-if="selectedCrop==crop.id" class="card shadow rounded-1 mt-n3 pt-3 mb-5" style="border-radius: 20px">
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
import { ref, defineProps, defineEmits, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    farmTotalCost: Number,
    farmCropCosts: Object,
    selectedYear: Number,
    years: Array
});

let selectedCrop = ref()

const emit = defineEmits(['updateYear']);
const localSelectedYear = ref(props.selectedYear);

const selectYear = async (year) => {
    localSelectedYear.value = year;
    emit('updateYear', year);
};

watch(() => props.selectedYear, (newYear) => {
    localSelectedYear.value = newYear;
});

watch(() => props.farmYield, (newData) => {
    console.log('Updated farm yield data:', newData);
});

</script>