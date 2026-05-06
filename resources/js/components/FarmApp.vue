<template>

    <div class="card justify-content-center text-center" style="min-width: 300px">

        <div v-if="showDashboard" class="d-flex flex-column flex-grow-1">

            <div class="card-header bg-secondary mb-4 text-center">
                <h3>{{ farm.chef_upa }}</h3>
            </div>

            <div class="icon-grid">

                <div class="icon-item" @click="showCharacteristics=true; showDashboard=false">
                    <div class="icon-tile bg-warning">
                    <img src="/images/characteristics_icon.png" />
                    </div>
                    <div class="icon-label">CIKƐDA FƐNW</div>
                </div>

                <div class="icon-item" @click="showMap=true; showDashboard=false">
                    <div class="icon-tile bg-danger">
                    <img src="/images/map_icon.png" />
                    </div>
                    <div class="icon-label">JA WALAN</div>
                </div>

                <div class="icon-item" @click="showArea=true; showDashboard=false">
                    <div class="icon-tile bg-cyan">
                    <img src="/images/area_icon.png" />
                    </div>
                    <div class="icon-label">FƆRƆ</div>
                </div>

                <div class="icon-item" @click="showNeeds=true; showDashboard=false">
                    <div class="icon-tile bg-primary">
                    <img src="/images/planned_needs_icon.png" />
                    </div>
                    <div class="icon-label">BALO ƝƐBILALENW</div>
                </div>

                <div class="icon-item" @click="showCosts=true; showDashboard=false">
                    <div class="icon-tile bg-success">
                    <img src="/images/costs_icon.png" />
                    </div>
                    <div class="icon-label">MUSAKAW</div>
                </div>

                <div class="icon-item" @click="showProduction=true; showDashboard=false">
                    <div class="icon-tile bg-orange">
                    <img src="/images/production_icon.png" />
                    </div>
                    <div class="icon-label">SƆRƆ KUNBA</div>
                </div>

                <div class="icon-item" @click="showYield=true; showDashboard=false">
                    <div class="icon-tile" style="background:#d9777d;">
                    <img src="/images/yield_icon.png" />
                    </div>
                    <div class="icon-label">SƆRƆ LAKIKA</div>
                </div>

                <div class="icon-item" @click="showSoilNutrients=true; showDashboard=false">
                    <div class="icon-tile" style="background:#6B8E23;">
                    <img src="/images/soil_nutrients_icon.png" />
                    </div>
                    <div class="icon-label">DƆGƆ</div>
                </div>

                <div class="icon-item" @click="showObservations=true; showDashboard=false">
                    <div class="icon-tile" style="background:#d5befa;">
                    <img src="/images/observation_icon.png" />
                    </div>
                    <div class="icon-label">KƆLƆSILIW</div>
                </div>

            </div>

            <div class="card-footer bg-secondary mt-auto">
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

        <div v-if="showCharacteristics" class="d-flex flex-column flex-grow-1">

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

        <div v-if="showMap" class="d-flex flex-column flex-grow-1">

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

        <div v-if="showArea" class="d-flex flex-column flex-grow-1">

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

        <div v-if="showNeeds" class="d-flex flex-column flex-grow-1">

            <div class="card-header bg-primary mb-4">
                <div class="row">
                    <div class="col-4">
                        <img :src="`/images/planned_needs_icon.png`" height="55"/>
                    </div>
                    <div class="col text-left text-light pt-3">
                        <h3>BALO ƝƐBILALENW</h3>
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

        <div v-if="showCosts" class="d-flex flex-column flex-grow-1">

            <div class="card-header bg-success">
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

        <div v-if="showProduction" class="d-flex flex-column flex-grow-1">

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

        <div v-if="showYield" class="d-flex flex-column flex-grow-1">

            <div class="card-header mb-4 text-light" style="background:#d9777d;">
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

        <div v-if="showSoilNutrients" class="d-flex flex-column flex-grow-1">

            <div class="card-header mb-4" style="background:#6B8E23;">
                <div class="row">
                    <div class="col-4">
                        <img :src="`/images/soil_nutrients_icon.png`" height="55"/>
                    </div>
                    <div class="col text-left text-light pt-3">
                        <h3>DƆGƆ</h3>
                    </div>
                </div>
            </div>

            <FarmSoilNutrients :farm-soil-nutrients="farmSoilNutrients" :years="years" :selected-year="selectedYear" @updateYear="updateYear"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showSoilNutrients=false; showDashboard=true">
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

        <div v-if="showObservations" class="d-flex flex-column flex-grow-1">

            <div class="card-header mb-4" style="background:#d5befa;">
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
    import FarmSoilNutrients from "./FarmSoilNutrients.vue";

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
    let showSoilNutrients = ref(false)

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
    let farmSoilNutrients = ref({})
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

        const soilNutrientsResponse = await axios.get(`/farm/${props.farm.id}/FarmSoilNutrients/${year}`);
            console.log('API Soil Nutrients Response:', soilNutrientsResponse.data);
            farmSoilNutrients.value = soilNutrientsResponse.data;
    }

    const updateYear = async (year) => {
        selectedYear.value = year;
        await fetchData(year);
    };

</script>

<style scoped>

    /* Phone */

    .icon-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    padding: 15px;
    justify-items: center;
    }

    .icon-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    }

    .icon-tile {
    width: 70px;
    height: 70px;

    border-radius: 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    flex-shrink: 0;
    }

    .icon-tile img {
    width: 38px;
    height: 38px;
    object-fit: contain;
    }

    .icon-label {
    margin-top: 6px;
    font-size: 12px;
    text-align: center;
    font-weight: 500;
    max-width: 90px;
    line-height: 1.2;
    word-break: break-word;
    }
    
    .card {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
    /* Tablet */

    @media (min-width: 768px) {
        .icon-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            max-width: 600px;
            margin: 0 auto;
        }

        .icon-tile {
            width: 85px;
            height: 85px;
        }

        .icon-tile img {
            width: 44px;
            height: 44px;
        }

        .icon-label {
            font-size: 13px;
            max-width: 110px;
        }
    }

    /* Desktop */

    @media (min-width: 1024px) {
        .icon-grid {
            grid-template-columns: repeat(4, 1fr);
            max-width: 700px;
        }

        .icon-tile {
            width: 90px;
            height: 90px;
        }
    }
</style>