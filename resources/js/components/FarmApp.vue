<template>
    
    <div class="card justify-content-center text-center" style="min-width: 300px">

        <div v-if="showDashboard">
            <div class="card-header bg-secondary mb-4">
                <h1 justify-content-center>{{ farm.chef_upa }}</h1>
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
                    <button type="button" class="btn bg-cyan text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
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
                <a href="#costs">
                    <button type="button" class="btn btn-warning text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showCosts=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/costs_icon.png`" height="60"/>
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
                    <button type="button" class="btn btn-success text-light text-center w-100 py-2 mb-3" style="border-radius: 20px"
                        @click="showProduction=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/costs_icon.png`" height="60"/>
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
                    <button type="button" class="btn btn-primary text-light text-center w-100 py-2 mb-5" style="border-radius: 20px"
                        @click="showYield=true; showDashboard=false">
                        <div class="row">
                            <div class="col">
                                <img :src="`/images/costs_icon.png`" height="60"/>
                            </div>
                            <div class="col text-left pt-3">
                                <h5>SƆRƆ LAKIKA</h5>
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
                <button class="btn btn-info mr-2 my-2" type="button">
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

            <FarmMap :plot-coords="plotCoords" :interest-point-coords="interestPointCoords" :farm-center="farmCenter" :no-coords="noCoords"/>

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showMap=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button">
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
            
            <FarmArea :farm-total-area="farmTotalArea" :farm-primary-area="farmPrimaryArea" :farm-secondary-area="farmSecondaryArea" />

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showArea=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button">
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

            <div class="card-header bg-warning">
                <div class="row">
                    <div class="col-5 pl-5">
                        <img :src="`/images/costs_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>MUSAKAW</h3>
                    </div>
                </div>
            </div>
    
            <FarmCosts :farm-total-cost="farmTotalCost" :farm-crop-costs="farmCropCosts" />

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showCosts=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button">
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
            
            <div class="card-header bg-success mb-4">
                <div class="row">
                    <div class="col-5 pl-5">
                        <img :src="`/images/costs_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>SƆRƆ KUNBA</h3>
                    </div>
                </div>
            </div>

            <FarmProduction :farm-production="farmProduction" />

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showProduction=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button">
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
                        <img :src="`/images/costs_icon.png`" height="60"/>
                    </div>
                    <div class="col text-left pt-3">
                        <h3>SƆRƆ LAKIKA</h3>
                    </div>
                </div>
            </div>

            <FarmYield :farm-yield="farmYield" />

            <div class="card-footer fixed-bottom bg-secondary mt-5">
                <a href="#dashboard">
                    <button class="btn btn-info mr-4 my-2" type="button" @click="showYield=false; showDashboard=true">
                        <i class="la la-home"></i>
                    </button>
                </a>
                <button class="btn btn-info mr-2 my-2" type="button">
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

const props = defineProps({
    farm: Object,
    logoutRoute: String,
})

const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

let showDashboard = ref(true)
let showMap = ref(false)
let showArea = ref(false)
let showCosts = ref(false)
let showProduction = ref(false)
let showYield = ref(false)

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

    const area = await axios
        .get("/farm/"+ props.farm.id + "/FarmArea")
        farmTotalArea.value = area.data.totalArea
        farmPrimaryArea.value = area.data.primaryArea
        farmSecondaryArea.value = area.data.secondaryArea

    const costs = await axios
        .get("/farm/"+ props.farm.id + "/FarmCosts")
        farmTotalCost.value = costs.data.totalCost
        farmCropCosts.value = costs.data.cropCosts

    const production = await axios
        .get("/farm/"+ props.farm.id + "/FarmProduction")
        farmProduction.value = production.data
        
        const fyield = await axios
        .get("/farm/"+ props.farm.id + "/FarmYield")
        farmYield.value = fyield.data
}

</script>