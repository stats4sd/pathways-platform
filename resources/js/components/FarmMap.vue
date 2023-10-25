<template>

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
                  Foro tɔgɔ ye di: <b> {{ plot.field.nom }}</b><br/><br/>
                  Dugu kolo suguya: <b> {{ plot.field.type_sol }}</b><br/><br/>
                  Kɛnɛ fɛcɛ cogo: <b> {{ plot.field.pente }}</b><br/><br/>
                  Kɛnɛ mumɛ: <b> {{ plot.field.superficie_total }}</b><br/><br/>
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
                Kɛnɛ N⁰: <b> {{ plot.numero_parcelle }}</b><br/><br/>
                Jiri sun hakɛ: <b> {{ plot.nombre_arbre }}</b><br/><br/>
                Sɛnɛfen jɔnjɔn: <b> {{ plot.crop_id }}</b><br/><br/>
                Sɛnɛfen wɛrɛw: <b> {{ plot.cultures_associations }}</b><br/><br/>
                Fɔrɔ: <b> {{ plot.superficie_measuree}}</b><br/><br/>
                <a @click="fieldLevel=true; setFarmCenter(farmCenter)" href="#"><b>Sɛkili kana kɛnɛw la</b></a>
          </l-popup>
        </l-polygon>
      </div>

    </l-map>

  </div>

</template>
  
<script setup>
  import "leaflet/dist/leaflet.css";
  import leaflet, { polygon } from 'leaflet'
  import {ref} from "vue";
  import { LMap, LTileLayer, LMarker, LPopup, LPolygon, LControlLayers, LIcon} from "@vue-leaflet/vue-leaflet";

  const props = defineProps({
    interestPointCoords: Array,
    plotCoords: Array,
    farmCenter: Array,
  })

  console.log('this is the farm map')

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