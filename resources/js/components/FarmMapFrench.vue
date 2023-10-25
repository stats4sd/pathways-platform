<template>

  <div>
     <label for="checkboxInterestPoint">Points d'intérêt  </label>
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
                  Nom du champ: <b> {{ plot.field.nom }}</b><br/><br/>
                  Type sol: <b> {{ plot.field.type_sol }}</b><br/><br/>
                  Pente: <b> {{ plot.field.pente }}</b><br/><br/>
                  Superficie total: <b> {{ plot.field.superficie_total }}</b><br/><br/>
                  <a @click="fieldLevel=false; selectedField=plot.field.id; setFieldCenter(plot.field.center)" href="#"><b>Montrer les parcelles pour ce champ</b></a>
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
                Numero Parcelle: <b> {{ plot.numero_parcelle }}</b><br/><br/>
                Nombre Abre: <b> {{ plot.nombre_arbre }}</b><br/><br/>
                Culture: <b> {{ plot.crop_id }}</b><br/><br/>
                Cultures Associations: <b> {{ plot.cultures_associations }}</b><br/><br/>
                Superficie: <b> {{ plot.superficie_measuree}}</b><br/><br/>
                <a @click="fieldLevel=true; setFarmCenter(farmCenter)" href="#"><b>Retour aux champs</b></a>
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