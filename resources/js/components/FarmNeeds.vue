<template>
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-center align-items-center mt-4">
                <button class="btn bg-primary text-light dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="la la-calendar"></i> {{ localSelectedYear }}
                </button>
                <div class="dropdown-menu" aria-labelledby="yearDropdown">
                    <a class="dropdown-item" v-for="year in years" :key="year" @click="selectYear(year)">{{ year }}</a>
                </div>
            </div>
        </div>

        <div v-if="farmNeeds">
            <!-- Human Cereal Needs -->
            <div class="card shadow rounded-1 mb-4 p-3" style="border-radius: 20px">
                <div class="mb-3"><b>BALO ƝƐBILALEN</b></div>

                <div class="row">
                    <div class="col-7 text-left ml-3">
                        Cikɛda mɔgɔ hakɛ balo ta ɲɛbilalen
                    </div>
                    <div class="col text-left pl-2">
                        <b>{{ farmNeeds.personnes_nourrir }}</b>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-7 text-left ml-3">
                        Suman hakɛ ɲɛbilalen balo kama (bɔrɛ)
                    </div>
                    <div class="col text-left pl-2">
                        <b>{{ farmNeeds.besoin_cereale_exploitation }}</b>
                    </div>
                </div>
            </div>

            <!-- Animal Feed Needs -->
            <div class="card shadow rounded-1 mb-4 p-3" style="border-radius: 20px">
                <div class="mb-3"><b>BAGAN BALO ƝƐBILALEN</b></div>

                <!-- Animal categories -->
                <div v-for="animal in farmNeeds.liste_cat_animales" :key="animal.id" class="mb-2">
                    <div class="row">
                        <div class="col-7 text-left ml-3">
                            {{ animal.label }}
                        </div>
                        <div class="col text-left pl-2">
                            <b>{{ animal.total }}</b>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-7 text-left ml-3">Turuto ni bu hakɛ mumɛ (bɔrɛ)</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.total_concentre }}</b></div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-7 text-left ml-3">Bu hakɛ (bɔrɛ)</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.quantite_son }}</b></div>
                </div>

                <div class="row mt-4">
                    <div class="col-7 text-left ml-3">Turuto hakɛ (bɔrɛ)</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.quantite_tourteau }}</b></div>
                </div>

                <div class="row mt-4">
                    <div class="col-7 text-left ml-3">Ɲɔ kala hakɛ mumɛ (wotoro ɲɛ)</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.total_residu }}</b></div>
                </div>

                <div class="row mt-4">
                    <div class="col-7 text-left ml-3">Shɔ kala/bin jalen hakɛ mumɛ (kuru)</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.total_fane }}</b></div>
                </div>

                <hr>

                <div class="row mt-2">
                    <div class="col-7 text-left ml-3">Waari ɲɛbila hakɛ bagan balo kama</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.cal_depense_total ? farmNeeds.cal_depense_total + ' drm' : '' }}</b></div>
                </div>

                <div class="row mt-4">
                    <div class="col-7 text-left ml-3">Waari ɲɛbila hakɛ bagan furakɛli</div>
                    <div class="col text-left pl-2"><b>{{ farmNeeds.cal_depense_soins ? farmNeeds.cal_depense_soins + ' drm' : '' }}</b></div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
    farmNeeds: Object,
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

</script>
