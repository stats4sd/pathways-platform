<template>

    <form method="POST" :action="loginRoute">

        <div class="d-flex flex-column justify-content-center align-items-center">

            <h3>Scannez le code QR sur votre carte d'identité</h3>


            <video
                id="preview"
                class="m-4 w-100"
                :class="scannedCode ? 'border border-success' : ''"
            />

            <h4
                v-if="scannedCode"
                class="text-success d-flex justify-content-center align-items-center"
            >
                CODE SCANNED
                <i class="la la-check-circle font-weight-bold font-5xl text-success"></i>
            </h4>


            <p
                v-for="error in codeErrors"
                class="help-block text-danger">
                {{ error }}
            </p>

            <div class="my-4">
                <h5>Saisir votre numéro de téléphone: <br/><br/>
                    <input class="form-control" name='phone_number_text' v-model="phoneNumberText">
                </h5>
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
                class="mt-4 btn"
                :class="scannedCode && phoneNumber ? 'btn-primary' : 'btn-secondary'"
                :disabled="!scannedCode && !phoneNumber">
                Connexion
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
