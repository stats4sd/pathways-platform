<template>
    
    <div class="pl-2">

        <div class="card justify-content-center text-center" style="min-width: 300px">

            <div v-if="showDashboard">
                <div class="card-header bg-secondary mb-4">
                    <h1 justify-content-center>{{ farm.chef_upa }}</h1>
                </div>
                <div>
                    <a href="#map">
                        <button type="button" class="btn btn-danger text-light text-center w-100 py-2"
                        @click="showMap=true; showDashboard=false">
                            CARTE
                        </button>
                    </a>
                </div>
                <div>
                    <a href="#area">
                        <button type="button" class="btn btn-info text-light text-center w-100 py-2"
                        @click="showArea=true; showDashboard=false">
                            SUPERFICIE
                        </button>
                    </a>
                </div>
                <div>
                    <a href="#costs">
                        <button type="button" class="btn btn-warning text-light text-center w-100 py-2"
                        @click="showCosts=true; showDashboard=false">
                            COÛTS
                        </button>
                    </a>
                </div>
                <div>
                    <a href="#production">
                        <button type="button" class="btn btn-success text-light text-center w-100 py-2"
                        @click="showProduction=true; showDashboard=false">
                            PRODUCTION
                        </button>
                    </a>
                </div>
                <div>
                    <a href="#yield">
                        <button type="button" class="btn btn-primary text-light text-center w-100 py-2"
                        @click="showYield=true; showDashboard=false">
                            RENDEMENT
                        </button>
                    </a>
                </div>

                <div class="card-footer fixed-bottom bg-secondary mt-5">
                    <a href="#dashboard">
                        <button class="btn btn-info mr-4 my-2" type="button" @click="showDashboard=true">
                            <i class="la la-home"></i>
                        </button>
                    </a>
                    <button class="btn btn-info mr-4 my-2" type="submit"><i class="la la-language"></i>
                    </button>
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
                    <h1 justify-content-center>CARTE</h1>
                </div>

                <FarmMap :plot-coords="plotCoords" :interest-point-coords="interestPointCoords" :farm-center="farmCenter"/>

                <div class="card-footer fixed-bottom bg-secondary mt-5">
                    <a href="#dashboard">
                        <button class="btn btn-info mr-4 my-2" type="button" @click="showMap=false; showDashboard=true">
                            <i class="la la-home"></i>
                        </button>
                    </a>
                    <button class="btn btn-info mr-4 my-2" type="submit">
                        <i class="la la-language"></i>
                    </button>
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
                
                <div class="card-header bg-info mb-4">
                    <h1 justify-content-center>SUPERFICIE</h1>
                </div>
                
                <FarmArea />

                <div class="card-footer fixed-bottom bg-secondary mt-5">
                    <a href="#dashboard">
                        <button class="btn btn-info mr-4 my-2" type="button" @click="showArea=false; showDashboard=true">
                            <i class="la la-home"></i>
                        </button>
                    </a>
                    <button class="btn btn-info mr-4 my-2" type="submit">
                        <i class="la la-language"></i>
                    </button>
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

                <div class="card-header bg-warning mb-4">
                    <h1 justify-content-center>COÛTS</h1>
                </div>
     
                <FarmCosts />

                <div class="card-footer fixed-bottom bg-secondary mt-5">
                    <a href="#dashboard">
                        <button class="btn btn-info mr-4 my-2" type="button" @click="showCosts=false; showDashboard=true">
                            <i class="la la-home"></i>
                        </button>
                    </a>
                    <button class="btn btn-info mr-4 my-2" type="submit">
                        <i class="la la-language"></i>
                    </button>
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
                    <h1 justify-content-center>PRODUCTION</h1>
                </div>

                <FarmProduction />

                <div class="card-footer fixed-bottom bg-secondary mt-5">
                    <a href="#dashboard">
                        <button class="btn btn-info mr-4 my-2" type="button" @click="showProduction=false; showDashboard=true">
                            <i class="la la-home"></i>
                        </button>
                    </a>
                    <button class="btn btn-info mr-4 my-2" type="submit">
                        <i class="la la-language"></i>
                    </button>
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
                    <h1 justify-content-center>RENDEMENT</h1>
                </div>

                <FarmYield />

                <div class="card-footer fixed-bottom bg-secondary mt-5">
                    <a href="#dashboard">
                        <button class="btn btn-info mr-4 my-2" type="button" @click="showYield=false; showDashboard=true">
                            <i class="la la-home"></i>
                        </button>
                    </a>
                    <button class="btn btn-info mr-4 my-2" type="submit">
                        <i class="la la-language"></i>
                    </button>
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


// MAP

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