<template>
    <div class="container pt-5">
        <div class="card shadow-sm bg-light">
            <div class="card-header bg-light p-5">
                <FarmMapFrench :plot-coords="plotCoords" :interest-point-coords="interestPointCoords" :farm-center="farmCenter" :no-coords="noCoords"/>
            </div>
        </div>
    </div>

</template>

<script setup>
import {onMounted, ref} from "vue";
import FarmMapFrench from "./FarmMapFrench.vue";

const props = defineProps({
    farm: Object,
})


let plotCoords = ref([])
let interestPointCoords = ref([])
let farmCenter = ref([0,0])
let noCoords = ref()

onMounted(() => {
    console.log('Mounted Farm Page');
    getData()
})

const getData = async () => {
    console.log('Getting data from server and/or local storage');

    const coords = await axios
        .get("/farm/"+ props.farm.id + "/FarmMap")
        plotCoords.value = coords.data.plotCoords
        interestPointCoords.value = coords.data.interestPointCoords
        farmCenter.value = coords.data.farmCenter
        noCoords.value = coords.data.noCoords

}

</script>