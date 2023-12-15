<template>

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
            <b> Pas de données GPS pour cette UPA</b><br/>
          </l-popup>
        </l-marker>

      </l-map>
    </div>
  </div>

  <div v-else>
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

                    <img src="/images/soil_type.jpg" height="20"/> Type sol: <b> {{ plot.field.type_sol }}</b><br/><br/>
                    <img src="/images/pente.jpg" height="20"/> Pente: <b> {{ plot.field.pente }}</b><br/><br/>
                    <img src="/images/superf_champ.jpg" height="20"/> Superficie total: <b> {{ plot.field.superficie_total }} ha</b><br/><br/><br/>
                    
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
                  <h5><b>Numero Parcelle {{ plot.numero_parcelle }}</b></h5><br/>

                  <img src="/images/fertilite.jpg" height="15"/> Fertilite: <b> {{ plot.fertilite }}</b><br/><br/>
                  <img src="/images/arbre.jpg" height="20"/> Nombre Abre: <b> {{ plot.nombre_arbre }}</b><br/><br/>
                  <img src="/images/superf_unit.jpg" height="12"/> Superficie: <b> {{ plot.superficie_measuree}} ha</b><br/><br/><br/>

                  Culture: 
                  <br/><b> {{ plot.main_crop_fr }}</b> <img :src="`/images/${plot.main_crop_image}`" height="30"><br/><br/>
                                    
                  <div v-if="plot.cultures_associations">
                    Cultures Associations:

                    <div v-for="crop in plot.associated_crops" :key="crop.crop_fr">
                      <b> {{ crop.label_fr }}</b> <img :src="`/images/${crop.crop_image}`" height="30">
                    </div>
                    <br/><br/>
                  </div>
                  <div else><br/></div>

                  <a @click="fieldLevel=true; setFarmCenter(farmCenter)" href="#"><b>Retour aux champs</b></a>
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
  import {ref} from "vue";
  import { LMap, LTileLayer, LMarker, LPopup, LPolygon, LControlLayers, LIcon} from "@vue-leaflet/vue-leaflet";

  const props = defineProps({
    interestPointCoords: Array,
    plotCoords: Array,
    farmCenter: Array,
    noCoords: Boolean,
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