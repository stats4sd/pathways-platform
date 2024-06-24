<template>
  <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3> {{ seasonPhase }} - {{ cropName }}</h3>
        <span class="close" @click="closeModal">&times;</span>
      </div>
      <div v-if="type === 'text'" class="text-content">
          {{ content }}
      </div>
      <div v-else-if="type === 'image'">
        <img :src="content" alt="Observation Image" width=100% height=100%>
      </div>
      <div v-else-if="type === 'audio'">
          <audio controls>
              <source :src="content" type="audio/mpeg">
              Your browser does not support the audio tag.
        </audio>
      </div>
      <div v-else-if="type === 'video'">
          <video controls :src="content" width=100% height=100%>
            Your browser does not support the video tag.
          </video>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  isVisible: Boolean,
  content: String,
  type: String,
  cropName: String,
  seasonPhase: String
});

const emit = defineEmits(['closeModal']);

const closeModal = () => {
  emit('closeModal');
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  max-width: 80%;
  z-index: 10000;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 20px;
  color: #aaa;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding: 0;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.2em;
}

.modal-header h3 {
  margin: 0;
  font-size: 16px;
}

.audio-controls button {
  margin-right: 10px;
  cursor: pointer;
}

.text-content {
  text-align: left;
  white-space: pre-wrap;
}
</style>
