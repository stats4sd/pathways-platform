<template>

    <form method="POST" :action="loginRoute">

        <div class="d-flex flex-column justify-content-center align-items-center">

            <h3>Scannez le code QR sur votre carte d'identité</h3>

            <video id="preview" class="m-4 w-100"></video>

            <div class="my-4">
                <h5>Scanned code: <br/><br/>
                    <span class="font-weight-bold font-2xl">{{ scannedCode.data }}</span>
                </h5>
            </div>

            <input type="hidden" name='farm_code' v-model="scannedCode.data"/>
            <input type="hidden" name="_token" :value="csrf">

            <button type="submit" class="mt-4 btn" :class="scannedCode ? 'btn-primary' : 'btn-secondary'"
                    :disabled="!scannedCode">
                Login
            </button>
        </div>
    </form>
</template>

<script setup>

import QrScanner from 'qr-scanner';
import {onMounted, ref} from "vue";

const props = defineProps({
    loginRoute: String,
});

const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')


const scannedCode = ref('')


onMounted(async () => {

    const qrScanner = new QrScanner(
        document.getElementById('preview'),
        result => scannedCode.value = result,
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
