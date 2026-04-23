<template>

    <div class="card justify-content-center text-center" style="min-width: 300px">

        <div v-if="showDashboard">
            <div class="card-header bg-secondary mb-4">
                
                <h1 justify-content-center>{{ farm.chef_upa }}</h1>

            </div>
            <div class="center" style="width:90%; margin:auto">
                <a href="#characteristics">
                    <button type="button" class="btn btn-warning text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showCharacteristics=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/characteristics_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>CIKƐDA FƐNW</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>
            <div class="center" style="width:90%; margin:auto">
                <a href="#map">
                    <button type="button" class="btn btn-danger text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showMap=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/map_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>JA WALAN</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>
            <div class="center" style="width:90%; padding:4px; margin:auto">
                <a href="#area">
                    <button type="button" class="btn bg-cyan text-light text-center w-100 py-2 mb-5" style="border-radius: 20px"
                        @click="showArea=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/area_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>FƆRƆ</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>
            <div class="center" style="width:90%; padding:4px; margin:auto">
                <a href="#needs">
                    <button type="button" class="btn btn-success text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showNeeds=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/planned_needs_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>ƝƐBILALEN</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>
            <div class="center" style="width:90%; padding:4px; margin:auto">
                <a href="#costs">
                    <button type="button" class="btn btn-primary text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showCosts=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/costs_icon.png`" width="70"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>MUSAKAW</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>
            <div class="center" style="width:90%; padding:4px; margin:auto">
                <a href="#production">
                    <button type="button" class="btn bg-orange text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showProduction=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/production_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>SƆRƆ KUNBA</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>
            <div class="center" style="width:90%; padding:4px; margin:auto">
                <a href="#yield">
                    <button type="button" class="btn text-light text-center w-100 py-2 mb-5" style="background-color:#6B8E23; border-radius: 20px"
                        @click="showYield=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/yield_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>SƆRƆ LAKIKA</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>

            <div class="center" style="width:90%; padding:4px; margin:auto">
                <a href="#observations">
                    <button type="button" class="btn text-light text-center w-100 py-2 mb-5" style="background-color:#d5befa; border-radius: 20px"
                        @click="showObservations=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/observation_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>KƆLƆSILIW</h5>
                            </div>
                        </div>
                    </button>
                </a>
            </div>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="dashboard_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showCharacteristics">

            <div class="card-header bg-warning mb-4">
                <div class="row">
                    <div class="col-5 pl-5">
                        <img :src="`/images/characteristics_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>CIKƐDA FƐNW</h3>
                    </div>
                </div>
            </div>

            <FarmCharacteristics :farm-characteristics="farmCharacteristics"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showCharacteristics=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="map_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showMap">

            <div class="card-header bg-danger mb-4">
                <div class="row">
                    <div class="col-5 pl-5">
                        <img :src="`/images/map_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>JA WALAN</h3>
                    </div>
                </div>
            </div>

            <FarmMap :plot-coords="plotCoords" :interest-point-coords="interestPointCoords" :farm-center="farmCenter" :no-coords="!!noCoords"
                :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showMap=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="map_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showArea">

            <div class="card-header bg-cyan text-light">
                <div class="row">
                    <div class="col pl-5">
                        <img :src="`/images/area_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pr-3 pt-3">
                        <h3>FƆRƆ</h3>
                    </div>
                </div>
            </div>

            <FarmArea :farm-total-area="farmTotalArea" :farm-primary-area="farmPrimaryArea" :farm-secondary-area="farmSecondaryArea"
                :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showArea=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button"  @click="area_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showCosts">

            <div class="card-header bg-primary">
                <div class="row">
                    <div class="col-5 pl-5">
                        <img :src="`/images/costs_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>MUSAKAW</h3>
                    </div>
                </div>
            </div>

            <FarmCosts :farm-total-cost="farmTotalCost" :farm-crop-costs="farmCropCosts" :years="years"
                :selected-year="selectedYear" @updateYear="updateYear" />

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showCosts=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button"  @click="costs_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showProduction">

            <div class="card-header bg-orange text-light mb-4">
                <div class="row">
                    <div class="col-5 pl-5">
                        <img :src="`/images/production_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>SƆRƆ KUNBA</h3>
                    </div>
                </div>
            </div>

            <FarmProduction :farm-production="farmProduction" :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showProduction=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="production_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showYield">

            <div class="card-header bg-primary mb-4">
                <div class="row">
                    <div class="col-5">
                        <img :src="`/images/yield_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>SƆRƆ LAKIKA</h3>
                    </div>
                </div>
            </div>

            <FarmYield :farm-yield="farmYield" :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showYield=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="yield_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showObservations">

            <div class="card-header mb-4" style="background-color:#d5befa;">
                <div class="row">
                    <div class="col-4">
                        <img :src="`/images/observation_icon.png`" height="55"/>
                    </div>
                    <div class="col text-left text-light pt-3">
                        <h3>KƆLƆSILIW</h3>
                    </div>
                </div>
            </div>

            <FarmObservations :planting-observations="plantingObservations" :post-planting-observations="postPlantingObservations" :harvest-observations="harvestObservations"
                              :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showObservations=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="observations_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

        <div v-if="showNeeds">

            <div class="card-header bg-success mb-4">
                <div class="row">
                    <div class="col-4">
                        <img :src="`/images/planned_needs_icon.png`" height="55"/>
                    </div>
                    <div class="col text-left text-light pt-3">
                        <h3>ƝƐBILALEN</h3>
                    </div>
                </div>
            </div>

            <FarmNeeds :farm-needs="farmNeeds" :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showNeeds=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button" @click="needs_audio.play()">
                    <i class="la la-volume-up"></i>
                </button>
                <form method="POST" :action="logoutRoute" class="btn">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn btn-info my-2" type="submit"><i class="la la-lock"></i>
                    </button>
                </form>
            </div>

        </div>

    </div>


</template>

<script setup>
import {onMounted, ref} from "vue";
import FarmMap from "./FarmMap.vue";
import FarmArea from "./FarmArea.vue";
import FarmCosts from "./FarmCosts.vue";
import FarmProduction from "./FarmProduction.vue";
import FarmYield from "./FarmYield.vue";
import FarmObservations from "./FarmObservations.vue";
import FarmNeeds from "./FarmNeeds.vue";
import FarmCharacteristics from "./FarmCharacteristics.vue";

const props = defineProps({
    farm: Object,
    logoutRoute: String,
})

const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

let showDashboard = ref(true)
let showCharacteristics = ref(false)
let showMap = ref(false)
let showArea = ref(false)
let showCosts = ref(false)
let showProduction = ref(false)
let showYield = ref(false)
let showObservations = ref(false)

let plotCoords = ref([])
let interestPointCoords = ref([])
let farmCenter = ref([0,0])
let noCoords = ref()

let farmTotalArea = ref([])
let farmPrimaryArea = ref([])
let farmSecondaryArea = ref([])
let farmTotalCost = ref([])
let farmCropCosts = ref([])
let farmProduction = ref([])
let farmYield = ref([])
let plantingObservations = ref([])
let postPlantingObservations = ref([])
let harvestObservations = ref([])
let farmNeeds = ref({})
let farmCharacteristics = ref({})
let selectedYear = ref(null);
let years = ref([]);

let dashboard_audio = new Audio('/audio/dashboard_bm.mp3')
let map_audio = new Audio('/audio/map_bm.mp3')
let area_audio = new Audio('/audio/area_bm.mp3')
let costs_audio = new Audio('/audio/costs_bm.mp3')
let production_audio = new Audio('/audio/production_bm.mp3')
let yield_audio = new Audio('/audio/yield_bm.mp3')
let observations_audio = new Audio('/audio/observations_bm.mp3')
let needs_audio = new Audio('/audio/planned_needs_bm.mp3')


onMounted(() => {
    getData();
    console.log('Mounted Farm Page');
})

const getData = async () => {
    console.log('Getting data from server and/or local storage');

    const yearsResponse = await axios.get(`/farm/${props.farm.id}/FarmYears`);
    years.value = yearsResponse.data;

    selectedYear.value = years.value.length > 0 ? years.value[0] : null;

    if (selectedYear.value) {
        await fetchData(selectedYear.value);
    }
}

const fetchData = async (year) => {
    const coordsResponse = await axios.get(`/farm/${props.farm.id}/FarmMap/${year}`)
        console.log('API Map Response:', coordsResponse.data);
        plotCoords.value = coordsResponse.data.plotCoords
        interestPointCoords.value = coordsResponse.data.interestPointCoords
        farmCenter.value = coordsResponse.data.farmCenter
        noCoords.value = coordsResponse.data.noCoords

    const areaResponse = await axios.get(`/farm/${props.farm.id}/FarmArea/${year}`);
        console.log('API Area Response:', areaResponse.data);
        farmTotalArea.value = areaResponse.data.totalArea
        farmPrimaryArea.value = areaResponse.data.primaryArea
        farmSecondaryArea.value = areaResponse.data.secondaryArea

    const costsResponse = await axios.get(`/farm/${props.farm.id}/FarmCosts/${year}`);
        console.log('API Costs Response:', costsResponse.data);
        farmTotalCost.value = costsResponse.data.totalCost;
        farmCropCosts.value = costsResponse.data.cropCosts;

    const productionResponse = await axios.get(`/farm/${props.farm.id}/FarmProduction/${year}`);
        console.log('API Production Response:', productionResponse.data);
        farmProduction.value = productionResponse.data;

    const yieldResponse = await axios.get(`/farm/${props.farm.id}/FarmYield/${year}`);
        console.log('API Yield Response:', yieldResponse.data);
        farmYield.value = yieldResponse.data;

    const observationsResponse = await axios.get(`/farm/${props.farm.id}/FarmObservations/${year}`);
        console.log('API Observations Response:', observationsResponse.data);
        plantingObservations.value = observationsResponse.data.plantingObservations;
        postPlantingObservations.value = observationsResponse.data.postPlantingObservations;
        harvestObservations.value = observationsResponse.data.harvestObservations;

    const needsResponse = await axios.get(`/farm/${props.farm.id}/FarmNeeds/${year}`);
        console.log('API Needs Response:', needsResponse.data);
        farmNeeds.value = needsResponse.data;
    
    const characteristicsResponse = await axios.get(`/farm/${props.farm.id}/FarmCharacteristics`);
        console.log('API Characteristics Response:', characteristicsResponse.data);
        farmCharacteristics.value = characteristicsResponse.data;
}

const updateYear = async (year) => {
    selectedYear.value = year;
    await fetchData(year);
};

</script>
