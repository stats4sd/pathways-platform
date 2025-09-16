<template>
    <div class="row mb-5 pt-3">
          <div class="col-12 d-flex justify-content-center align-items-center">
            <div>
              <button class="btn btn-danger dropdown-toggle" type="button" id="yearDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="la la-calendar"></i> {{ localSelectedYear }}
              </button>
              <div class="dropdown-menu" aria-labelledby="yearDropdown">
                <a class="dropdown-item" v-for="year in years" :key="year" @click="selectYear(year)">{{ year }}</a>
              </div>
            </div>
          </div>
    </div>

      <div v-if="noCoords==1">
        <div style="height:500px">
          <l-map ref="map" v-model:zoom="zoom" :center="farmCenter" :use-global-leaflet="false">

            <l-tile-layer
              url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
              layer-type="base"
              name="OpenStreetMap"
              attribution='&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            ></l-tile-layer>

            <l-marker :lat-lng="farmCenter">
              <l-icon
              :icon-size="[35, 35]"
              icon-url="/images/question_icon.png"
              />
              <l-popup>
                <b>Kunafoniw ta fɔlo fɔrɔ kɛnɛ wali cikɛda nafa siraw kan walassa uw jaw ka bɔ yan</b><br/>
              </l-popup>
            </l-marker>

          </l-map>
        </div>
      </div>

      <div v-else>
        <div>
          <label for="checkboxInterestPoint">Cikɛda nafa sira  </label>
            <input
              id="checkboxInterestPoint"
              v-model="show"
              type="checkbox"
            >
        </div>

          <div style="height:500px">

          <l-map ref="map" v-model:zoom="zoom" :center="farmCenter" :use-global-leaflet="false">

            <l-tile-layer
              url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
              layer-type="base"
              name="OpenStreetMap"
              attribution='&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            ></l-tile-layer>

            <div v-if="show">
              <l-marker
                v-for="interestPoint in interestPointCoords" :key="interestPoint.id" :lat-lng="interestPoint.latlng"
                >
                <l-icon :icon-url="interestPoint.icon" :icon-size="[25, 25]"></l-icon>
                  <l-popup>
                    <b> {{ interestPoint.nom }}</b><br/>
                  </l-popup>
              </l-marker>
            </div>

            <div v-if="fieldLevel">
              <l-polygon
                v-for="plot in plotCoords"
                  :key="plot.id"
                  :lat-lngs="plot.latlngs"
                  :stroke="false"
                  :fill="true"
                  :fillOpacity="0.8"
                  :fillColor="plot.field_color"
              >
                <l-popup>
                        <h5><b>{{ plot.field.nom }}</b></h5><br/>

                        <img src="/images/soil_type.jpg" height="20"/> Dugu kolo suguya: <b> {{ plot.field.type_sol_bm }}</b><br/><br/>
                        <img src="/images/pente.jpg" height="20"/> Kɛnɛ fɛcɛ cogo: <b> {{ plot.field.pente_bm }}</b><br/><br/>
                        <img src="/images/superf_champ.jpg" height="20"/> Kɛnɛ mumɛ: <b> {{ plot.field.superficie_total }} ha</b><br/><br/><br/>

                        <a @click="fieldLevel=false; selectedField=plot.field.id; setFieldCenter(plot.field.center)" href="#"><b>Kɛnɛ jirali fɔrɔ kɔnɔ</b></a>
                </l-popup>
              </l-polygon>
            </div>

            <div v-if="!fieldLevel">
              <l-polygon
                v-for="plot in plotCoords"
                  :key="plot.id"
                  :lat-lngs="plot.latlngs"
                  :color="plot.field_color"
                  :opacity="setFieldOpacity(plot.field.id, selectedField)"
                  :fill="true"
                  :fillOpacity="setFieldFillOpacity(plot.field.id, selectedField)"
                  :fillColor="plot.field_color"
              >
                <l-popup>
                      <h5><b>Kɛnɛ N⁰ {{ plot.numero_parcelle }}</b></h5><br/>

                      <img src="/images/fertilite.jpg" height="15"/> Dugu kolo fanga: <b> {{ plot.fertilite_bm }}</b><br/><br/>
                      <img src="/images/arbre.jpg" height="20"/> Jiri sun hakɛ: <b> {{ plot.nombre_arbre }}</b><br/><br/>
                      <img src="/images/superf_unit.jpg" height="12"/> Fɔrɔ: <b> {{ plot.superficie_measuree}} ha</b><br/><br/><br/>

                      Sɛnɛfen jɔnjɔn:
                      <br/><b> {{ plot.main_crop_bm }}</b> <img :src="`/images/${plot.main_crop_image}`" height="30"><br/><br/>

                      <div v-if="plot.cultures_associations">
                        Sɛnɛfen wɛrɛw:

                        <div v-for="crop in plot.associated_crops" :key="crop.crop_bm">
                          <b> {{ crop.label_bm }}</b> <img :src="`/images/${crop.crop_image}`" height="30">
                        </div>
                        <br/><br/>
                      </div>
                      <div v-else><br/></div>

                      <a @click="fieldLevel=true; setFarmCenter(farmCenter)" href="#"><b>Sɛkili kana kɛnɛw la</b></a>
                </l-popup>
              </l-polygon>
            </div>
          </l-map>
        </div>
      </div>

</template>

<script setup>
  import "leaflet/dist/leaflet.css";
  import leaflet, { polygon } from 'leaflet'
  import {ref, defineEmits, watch} from "vue";
  import { LMap, LTileLayer, LMarker, LPopup, LPolygon, LControlLayers, LIcon} from "@vue-leaflet/vue-leaflet";

  const props = defineProps({
    interestPointCoords: Array,
    plotCoords: Array,
    farmCenter: Array,
    noCoords: Boolean,
    selectedYear: String,
    years: Array
  })

  const emit = defineEmits(['updateYear']);
  const localSelectedYear = ref(props.selectedYear);

  const selectYear = (year) => {
      localSelectedYear.value = year;
      emit('updateYear', year);
  };

  watch(() => props.selectedYear, (newYear) => {
      localSelectedYear.value = newYear;
  });

  let show = ref(true)
  let fieldLevel = ref(true)
  let zoom = ref(15)

  const map=ref()

  function setFieldCenter(centerPoint){
    map.value.leafletObject.setView(centerPoint, 16)
  }

  function setFarmCenter(centerPoint){
    map.value.leafletObject.setView(centerPoint, 15)
  }

  function setFieldOpacity(fieldId, selectedField){
    if(fieldId===selectedField){
      return 0.8
    }
    else {
      return  0.4
    }
  }

  function setFieldFillOpacity(fieldId, selectedField){
    if(fieldId===selectedField){
      return 0.6
    }
    else {
      return  0.3
    }
  }

</script>
