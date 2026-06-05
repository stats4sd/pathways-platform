<template>
  <div class="container">
    <div class="row mb-5 pt-3">

        <div class="card-body">
          <p>Nutrient balance data will be displayed here.</p>
        </div>
        
    </div>
  </div>
</template>

<script setup>
import { defineProps, watch } from 'vue';

const props = defineProps({
    farmSoilNutrients: Object,

});

watch(() => props.farmSoilNutrients, (newData) => {
    console.log('Updated farm soil nutrients data:', newData);
});
</script>
