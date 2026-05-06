<template>
  <div class="container">
    <div class="row mb-5 pt-3">

      <div class="card shadow rounded-1 mb-4 p-3" style="border-radius: 20px; width: 90%; margin:auto;">

        <div class="row text-left">
          <div class="col-7 ml-3 text-left">Gatigi tɔgɔ n’a jamu</div>
          <div class="col pl-2 text-left"><b>{{ farmCharacteristics.chef_upa }}</b></div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Dugu tɔgɔ</div>
          <div class="col pl-2 text-left"><b>{{ farmCharacteristics.village_id }}</b></div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Forokɛnɛ sɛnɛta hakɛ (taari)</div>
          <div class="col pl-2 text-left">
            <b v-if="farmCharacteristics.superficie_cultive_upa !== null">
              {{ farmCharacteristics.superficie_cultive_upa }}
            </b>
          </div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Cikɛda mɔgɔ hakɛ</div>
          <div class="col pl-2 text-left"><b>{{ farmCharacteristics.upa_membres }}</b></div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Siɛri daba hakɛ</div>
          <div class="col pl-2 text-left"><b>{{ farmCharacteristics.nombre_charrues }}</b></div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Tɛrɛkitɛri hakɛ</div>
          <div class="col pl-2 text-left"><b>{{ farmCharacteristics.nombre_tracteur }}</b></div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Cikɛda bɛ kulu fɛ</div>
          <div class="col pl-2 text-left"><b>{{ farmCharacteristics.type }}</b></div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Taari kelen sɛnɛ jɔlen do ni mɔgɔ hakɛ ye</div>
          <div class="col pl-2 text-left">
            <b v-if="farmCharacteristics.ratio_membre_terre !== null">
              {{ farmCharacteristics.ratio_membre_terre }}
            </b>
          </div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Taari kelen baaralen do ni baarakɛ fanga hakɛ min ye</div>
          <div class="col pl-2 text-left">
            <b v-if="farmCharacteristics.ratio_actif_terre !== null">
              {{ farmCharacteristics.ratio_actif_terre }}
            </b>
          </div>
        </div>

        <div class="row mt-3 text-left">
          <div class="col-7 ml-3 text-left">Taari kelen baaralen do ni cikɛ tura hakɛ min ye</div>
          <div class="col pl-2 text-left">
            <b v-if="farmCharacteristics.ratio_boeuflabour_terre !== null">
              {{ farmCharacteristics.ratio_boeuflabour_terre }}
            </b>
          </div>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { defineProps, watch } from 'vue';

const props = defineProps({
    farmCharacteristics: Object,

});

watch(() => props.farmCharacteristics, (newData) => {
    console.log('Updated farm characteristics data:', newData);
});
</script>
