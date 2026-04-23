<template>
  <div>
      <ObservationModal
          :isVisible="modalContent !== ''"
          :content="modalContent"
          :type="modalType"
          :cropName="modalCropName"
          :seasonPhase="modalSeasonPhase"
          @closeModal="closeModal"/>

    <div class="row mb-5 pt-3">

      <div class="col-12 d-flex justify-content-center align-items-center">
        <div>
          <button class="btn text-light dropdown-toggle" style="background-color:#d5befa;" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="la la-calendar"></i> {{ localSelectedYear }}
          </button>
          <div class="dropdown-menu" aria-labelledby="yearDropdown">
            <a class="dropdown-item" v-for="year in years" :key="year" @click="selectYear(year)">{{ year }}</a>
          </div>
        </div>
      </div>

        <div v-if="plantingObservations && plantingObservations.length > 0" class="col-12 mt-5">
            <b>DANNI WATI</b>
        </div>
        <div class="d-flex col mt-4" v-for="crop in plantingObservations" :key="crop.id">
            <div>
                <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
            </div>
            <div class="text-left">
                <b>{{ crop.label_bm }}</b>
                <div class="d-flex mt-1">
                    <div v-if="crop.observation_audio" class="icon-wrapper" @click="openObservationModal(crop.observation_audio, 'audio', crop.label_bm, 'DANNI WATI')">
                        <i class="las la-volume-up la-2x mr-2" title="Audio Icon"></i>
                      </div>
                      <div v-if="crop.observation_image" class="icon-wrapper" @click="openObservationModal(crop.observation_image, 'image', crop.label_bm, 'DANNI WATI')">
                        <i class="las la-camera la-2x mr-2" title="Image Icon"></i>
                      </div>
                      <div v-if="crop.observation_texte" class="icon-wrapper" @click="openObservationModal(crop.observation_texte, 'text', crop.label_bm, 'DANNI WATI')">
                        <i class="las la-file-alt la-2x mr-2" title="Text Icon"></i>
                      </div>
                      <div v-if="crop.observation_video" class="icon-wrapper" @click="openObservationModal(crop.observation_video, 'video', crop.label_bm, 'DANNI WATI')">
                        <i class="las la-video la-2x mr-2" title="Video Icon"></i>
                      </div>
                </div>
            </div>
        </div>

        <div v-if="postPlantingObservations && postPlantingObservations.length > 0" class="col-12 mt-5">
            <b>DANNI KOFƐ</b>
        </div>
        <div class="d-flex col mt-4" v-for="crop in postPlantingObservations" :key="crop.id">
            <div>
                <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
            </div>
            <div class="text-left">
                <b>{{ crop.label_bm }}</b>
                <div class="d-flex mt-1">
                    <div v-if="crop.observation_audio" class="icon-wrapper" @click="openObservationModal(crop.observation_audio, 'audio', crop.label_bm, 'DANNI KOFƐ')">
                        <i class="las la-volume-up la-2x mr-2" title="Audio Icon"></i>
                    </div>
                    <div v-if="crop.observation_image" class="icon-wrapper" @click="openObservationModal(crop.observation_image, 'image', crop.label_bm, 'DANNI KOFƐ')">
                        <i class="las la-camera la-2x mr-2" title="Image Icon"></i>
                    </div>
                    <div v-if="crop.observation_texte" class="icon-wrapper" @click="openObservationModal(crop.observation_texte, 'text', crop.label_bm, 'DANNI KOFƐ')">
                        <i class="las la-file-alt la-2x mr-2" title="Text Icon"></i>
                    </div>
                    <div v-if="crop.observation_video" class="icon-wrapper" @click="openObservationModal(crop.observation_video, 'video', crop.label_bm, 'DANNI KOFƐ')">
                        <i class="las la-video la-2x mr-2" title="Video Icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="harvestObservations && harvestObservations.length > 0" class="col-12 mt-5">
            <b>KƆƆRIBƆ NI ƝƆTIGƐ</b>
        </div>
        <div class="d-flex col mt-4" v-for="crop in harvestObservations" :key="crop.id">
            <div>
                <img :src="`/images/${crop.nom_fichier_image}`" width="70" class="mb-4 pr-2 ml-2" />
            </div>
            <div class="text-left">
                <b>{{ crop.label_bm }}</b>
                <div class="d-flex mt-1">
                    <div v-if="crop.observation_audio" class="icon-wrapper" @click="openObservationModal(crop.observation_audio, 'audio', crop.label_bm, 'KƆƆRIBƆ NI ƝƆTIGƐ')">
                        <i class="las la-volume-up la-2x mr-2" title="Audio Icon"></i>
                    </div>
                    <div v-if="crop.observation_image" class="icon-wrapper" @click="openObservationModal(crop.observation_image, 'image', crop.label_bm, 'KƆƆRIBƆ NI ƝƆTIGƐ')">
                        <i class="las la-camera la-2x mr-2" title="Image Icon"></i>
                    </div>
                    <div v-if="crop.observation_texte" class="icon-wrapper" @click="openObservationModal(crop.observation_texte, 'text', crop.label_bm, 'KƆƆRIBƆ NI ƝƆTIGƐ')">
                        <i class="las la-file-alt la-2x mr-2" title="Text Icon"></i>
                    </div>
                    <div v-if="crop.observation_video" class="icon-wrapper" @click="openObservationModal(crop.observation_video, 'video', crop.label_bm, 'KƆƆRIBƆ NI ƝƆTIGƐ')">
                        <i class="las la-video la-2x mr-2" title="Video Icon"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';
import ObservationModal from './ObservationModal.vue';

const props = defineProps({
    plantingObservations: Object,
    postPlantingObservations: Object,
    harvestObservations: Object,
    selectedYear: String,
    years: Array,
    isVisible: Boolean,
    content: String,
    type: String,
    cropName: String
});

const emit = defineEmits(['updateYear', 'openObservationModal']);

const localSelectedYear = ref(props.selectedYear);
const modalContent = ref('');
const modalType = ref('');
const modalCropName = ref('');
const modalSeasonPhase = ref('');

const selectYear = async (year) => {
    localSelectedYear.value = year;
    emit('updateYear', year);
};

const openObservationModal = (content, type, cropName, seasonPhase) => {
    modalContent.value = content;
    modalType.value = type;
    modalCropName.value = cropName;
    modalSeasonPhase.value = seasonPhase;
};

const closeModal = () => {
  modalContent.value = '';
  modalType.value = '';
  modalCropName.value = '';
  modalSeasonPhase.value = '';
};

watch(() => props.selectedYear, (newYear) => {
    localSelectedYear.value = newYear;
});

watch(() => props.farmObservations, (newData) => {
    console.log('Updated farm observations data:', newData);
});

</script>
