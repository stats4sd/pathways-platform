<template>
    <div class="container pt-5">
        <div class="card shadow-sm bg-light">
            <div class="card-header bg-light p-5">
                <FarmMap :plot-coords="plotCoords" :interest-point-coords="interestPointCoords" :farm-center="farmCenter"/>
            </div>
        </div>
    </div>

</template>

<script setup>
import {onMounted, ref} from "vue";
import FarmMap from "./FarmMap.vue";

const props = defineProps({
    farm: Object,
})


let plotCoords = ref([])
let interestPointCoords = ref([])
let farmCenter = ref([0,0])

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

    console.log(plotCoords)
    console.log(interestPointCoords)
    console.log(farmCenter)
}

</script>