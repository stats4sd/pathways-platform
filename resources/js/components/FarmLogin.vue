<template>

    <form method="POST" :action="loginRoute">

        <div class="d-flex flex-column justify-content-center align-items-center">

            <h3>Cikɛda numerɔ kunafoni ta ni kamera ye</h3>
            <img src="images/qr_code.png" id="image_qr" width="35"/>
            <br/><br/>

            <video
                id="preview"
                class="m-4 w-100"
                :class="scannedCode ? 'border border-success' : ''"
            />

            <h4
                v-if="scannedCode"
                class="text-success d-flex justify-content-center align-items-center"
            >
                Cikɛda numerɔ tala
                <i class="la la-check-circle font-weight-bold font-5xl text-success"></i>
            </h4>


            <p
                v-for="error in codeErrors"
                class="help-block text-danger">
                {{ error }}
            </p>

            <div class="my-4">
                <br/><br/>
                <h3>Cikɛda talefone numerɔ don</h3>
                <img src="images/phone_number.png" id="image_phone" width="35"/>
                <br/>
                <input class="form-control mt-4" name='phone_number_text' v-model="phoneNumberText">
                <p
                    v-for="error in phoneNumberErrors"
                    class="help-block text-danger">
                    {{ error }}
                </p>
            </div>

            <input type="hidden" name="phone_number" v-model="phoneNumber"/>
            <input type="hidden" name='code' v-model="scannedCode.data"/>
            <input type="hidden" name="_token" :value="csrf">

            <button
                type="submit"
                class="mt-4 mb-5 btn"
                :class="scannedCode && phoneNumber ? 'btn-primary' : 'btn-secondary'"
                :disabled="!scannedCode && !phoneNumber">
                Yɛlɛ a kan
            </button>
        </div>
    </form>
</template>

<script setup>

import QrScanner from 'qr-scanner';
import {computed, onMounted, ref} from "vue";

const props = defineProps({
    loginRoute: String,
    codeErrors: Array,
    phoneNumberErrors: Array,
    oldPhoneNumber: String,
});

const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')


const scannedCode = ref('')
const phoneNumberText = ref('')


const phoneNumber = computed(() => phoneNumberText.value.replaceAll(/\D/ig, ''))

onMounted(async () => {

    if(props.oldPhoneNumber) {
        phoneNumberText.value = props.oldPhoneNumber;
    }

    const qrScanner = new QrScanner(
        document.getElementById('preview'),
        result => {
            scannedCode.value = result
        },
        {
            returnDetailedScanResult: true,
        },
    );

    let stream = null;

    try {
        const navigator = window.navigator

        stream = await navigator.mediaDevices.getUserMedia();

    } catch (err) {
        console.log('error', err)
    }

    qrScanner.start()
})


</script>
