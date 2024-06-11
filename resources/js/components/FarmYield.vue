<template>
  <div>
    <div class="row mb-5 pt-3">
      <div class="col-12 d-flex justify-content-center align-items-center">
        <div>
          <button class="btn btn-primary dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="la la-calendar"></i> {{ localSelectedYear }}
          </button>
          <div class="dropdown-menu" aria-labelledby="yearDropdown">
            <a class="dropdown-item" v-for="year in years" :key="year" @click="selectYear(year)">{{ year }}</a>
          </div>
        </div>
      </div>
      <div class="d-flex col mt-5" v-for="crop in farmYield.cropYields" :key="crop.id">
          <div>
              <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
          </div>
          <div class="text-left">
              <b>{{ crop.label_bm }}<br>
                  {{ crop.yield }} kg/ha</b>
          </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
    farmYield: Object,
    selectedYear: String,
    years: Array
});

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
